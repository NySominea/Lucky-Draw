<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;
use App\Http\Requests\Phone\CreateRequest;
use App\Http\Requests\Phone\UpdateRequest;
use App\Repositories\Phone\PhoneRepository;

class PhoneController extends Controller
{
    public function __construct(PhoneRepository $repository){
        $this->middleware('permission:Phone Read');
        $this->middleware('permission:Phone Create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Phone Edit', ['only' => ['update']]);
        $this->middleware('permission:Phone Delete', ['only' => ['destroy']]);

        $this->repository = $repository;
    }

    public function index()
    {
        return view('phone.index', [
            'phones' => $this->repository->select()->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function store(CreateRequest $request)
    {
        if ($this->repository->createOrUpdate($request->all())) {
            return redirect()->route('phones.index')
                            ->withSuccess('You have just added a phone successfully');
        }

        $this->redirectBackWithErrors();
    }

    public function edit(Phone $phone)
    {
        return view('phone.index', [
            'phone' => $phone,
            'phones' => $this->repository->select()->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function update(UpdateRequest $request, Phone $phone)
    {
        if ($this->repository->createOrUpdate($request->all(), $phone->id)) {
            return redirect()->route('phones.index')
                            ->withSuccess('You have just updated a phone successfully');
        }

        $this->redirectBackWithErrors();
    }

    public function destroy($id)
    {
        if ($this->repository->delete($id)) {
            return redirect()->route('phones.index')
                            ->withSuccess('You have just deleted a phone successfully');
        }

        return $this->redirectBackWithErrors();
    }
}
