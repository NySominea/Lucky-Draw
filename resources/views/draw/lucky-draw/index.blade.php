<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=0"> -->
    <!-- <link rel="stylesheet" href="assets/style/bootstrap.min.css"> -->
    <title>Lucky Draw | {{ $settings[SettingKey::SiteName] }}</title>
    <link rel="shortcut icon" href="{{ $settings[SettingKey::SiteLogo] }}">

    <link rel="stylesheet" href="{{ asset('lucky-draw/style/style.css') }}">
</head>
<body>
    <header></header>
    @if (Draw::currentDrawingRound())
    <main>
        <div class="input-group">
            <div class="group">
                @for ($i=0; $i<5; $i++)
                    @if (isset($selectedPhones, $selectedPhones[$i]))
                    <input type="text" id="slot{{$i + 1}}" class="form-control slot" value="{{ $selectedPhones[$i]->phone->value }}" disabled>
                    @else
                    <input type="text" id="slot{{$i + 1}}" class="form-control slot available" value="" disabled>
                    @endif
                @endfor
            </div>
            <div class="main-input">
                <input id="random-box" type="text" class="form-control" value="" disabled>
                {{-- <span class="random">Test</span> --}}
                <img src="{{ $draw->mediaUrl('thumb') }}" alt="" class="prize">
            </div>
            <div class="group">
                @for ($i=5; $i<10; $i++)
                    @if (isset($selectedPhones, $selectedPhones[$i]))
                    <input type="text" id="slot{{$i + 1}}" class="form-control slot" value="{{ $selectedPhones[$i]->phone->value }}" disabled>
                    @else
                    <input type="text" id="slot{{$i + 1}}" class="form-control slot available" value="" disabled>
                    @endif
                @endfor
            </div>
        </div>
        <input type="hidden" name="round_number" value="{{ $draw->round_number }}">
        <input type="hidden" name="prize_qty" value="{{ $draw->prizes->sum('pivot.qty') }}">
        <input type="hidden" name="phones" value="{{ json_encode($phones) }}">
    </main>
    @else
    <main class="no-active" style="display: flex; align-items: center; justify-content: center;">
        <h1 style="color: red">No Drawing Round</h1>
    </main>
    @endif
    <footer id="footer">
        <button class="btn" id="btn-start">start</button>
        <button class="btn" id="btn-stop">stop</button>
    </footer>

    <script src="{{ asset('lucky-draw/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('lucky-draw/js/descrambler.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#btn-start').click(function(e) {
                e.preventDefault();

                var avaiableSlots = $('input.slot.available');

                if (avaiableSlots.length) {
                    startRandomly()
                }

                if (avaiableSlots.length === 10) {
                    $.ajax({
                        type:'POST',
                        url: "{{ route('draws.lucky-draw.start') }}",
                        data: {},
                        success:function(response){},
                        error:function(xhr, status, error){
                            alert(err.message)
                        }
                    });
                }
            })

            $('#btn-stop').click(function(e) {
                e.preventDefault();
                var avaiableSlots = $('input.slot.available');
                if (interval && avaiableSlots.length > 0) {
                    $.ajax({
                        type:'GET',
                        url: "{{ route('draws.lucky-draw.random') }}",
                        data: {
                            round_number: $('input[name="round_number"]').val()
                        },
                        success:function(response){
                            if (response.success) {
                                $('#random-box').val(response.phone)
                                avaiableSlots.first().removeClass('available').val(response.phone)

                                if($('input.slot').not('.available').length == $('input[name="prize_qty"]').val()) {
                                    $('#btn-start').remove();
                                    $('#btn-stop').remove();
                                    $('#footer').append('<a href="" class="btn" id="btn-next">Next Round</a>')
                                }
                            } else {
                                $('#random-box').val(response.message)
                            }
                        },
                        error:function(xhr, status, error){
                            alert(err.message)
                        },
                        complete: function() {
                            stopRandomly()
                        }
                    });
                }
            })


            var interval = null;
            var randomValue = null;
            var phones = [];
            function startRandomly() {
                phones = JSON.parse($('input[name="phones"]').val());
                if (phones.length == 0) return;
                if (phones.length == 1) {
                    randomValue = 0;
                    stopRandomly();
                    return;
                }
                interval = setInterval(function () {
                    randomValue = getRandomInt(0, phones.length - 1);
                    $('#random-box').val(phones[randomValue]);
                }, 100);
            }

            function stopRandomly() {
                clearInterval(interval);
                interval = null
            }

            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
        })
    </script>
</body>
</html>
