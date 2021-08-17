<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Helper\Mask;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('read_client')){
            abort(403);
        }

        if ($request->ajax()) {
            $client = $this->client->get();
            return DataTables::of($client)
                ->addIndexColumn()
                ->addColumn('action', function ($client) {
                    $data = '';
                    if(auth()->user()->hasPermissionTo('update_client')){
                        $data .= '<a href="' . route('admin.bets.clients.edit', ['client' => $client->id]) . '">
                        <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                    </a>';
                    }
                    /*if(auth()->user()->hasPermissionTo('delete_client')) {
                        $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_client" client="' . $client->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_client"> <i class="far fa-trash-alt"></i></button>';
                    }*/
                    return $data;
                })
                ->editColumn('name', function ($client) {
                    return $client->name. ' '. $client->last_name;
                })
                ->editColumn('cpf', function ($client) {
                    return Mask::addMaskCpf($client->cpf);
                })
                ->editColumn('created_at', function ($client) {
                    return Carbon::parse($client->created_at)->format('d/m/Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.bets.client.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->hasPermissionTo('create_client')){
            abort(403);
        }

        return view('admin.pages.bets.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('create_client')){
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'last_name' => 'required|max:100',
           // 'cpf' => 'required|max:14',
            'phone' => 'required|max:100',
           // 'email' => 'unique:App\Models\User|email:rfc|required|max:100',
           // 'bank' => 'required|max:100',
            //'agency' => 'required|max:20',
           // 'type_account' => 'required|max:20',
          //  'account' => 'required|max:50',
          //  'pix' => 'required|max:50',
//            'password' => 'min:8|same:password_confirmation|required|max:15',
//            'password_confirmation' => 'required|max:15',
        ]);

        $request['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);
        $request['phone'] = preg_replace('/[^0-9]/', '', $request->phone);

        try {
            $client = new $this->client;
            $client->cpf = $request->cpf;
            $client->name = $request->name;
            $client->last_name = $request->last_name;
            $client->ddd = substr($request->phone, 0, 2);
            $client->phone = substr($request->phone, 2);
            $client->email = $request->email;
            $client->bank = $request->bank;
            $client->type_account = $request->type_account;
            $client->agency = $request->agency;
            $client->account = $request->account;
            $client->pix = $request->pix;
//            $client->password = Hash::make('alterar123');
            $client->save();

            return redirect()->route('admin.bets.clients.index')->withErrors([
                'success' => 'Cliente cadastrado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.clients.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o cliente, tente novamente'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if(!auth()->user()->hasPermissionTo('update_client')){
            abort(403);
        }

        return view('admin.pages.bets.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        if(!auth()->user()->hasPermissionTo('update_client')){
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'cpf' => 'required|max:14',
            'phone' => 'required|max:100',
            'email' => 'email:rfc|required|max:100|unique:users,email,' . $client->id,
            'bank' => 'required|max:100',
            'agency' => 'required|max:20',
            'type_account' => 'required|max:20',
            'account' => 'required|max:50',
            'pix' => 'required|max:50',
//            'password' => 'min:8|same:password_confirmation|required|max:15',
//            'password_confirmation' => 'required|max:15',
        ]);

        $request['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);
        $request['phone'] = preg_replace('/[^0-9]/', '', $request->phone);

        try {

            $client->cpf = $request->cpf;
            $client->name = $request->name;
            $client->last_name = $request->last_name;
            $client->ddd = substr($request->phone, 0, 2);
            $client->phone = substr($request->phone, 2);
            $client->email = $request->email;
            $client->email = $request->email;
            $client->bank = $request->bank;
            $client->type_account = $request->type_account;
            $client->agency = $request->agency;
            $client->account = $request->account;
            $client->pix = $request->pix;
//            $client->password = Hash::make('alterar123');
            $client->save();

            return redirect()->route('admin.bets.clients.index')->withErrors([
                'success' => 'Cliente alterado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.clients.edit')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao alterar o cliente, tente novamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if(!auth()->user()->hasPermissionTo('delete_client')){
            abort(403);
        }

        try {
            $client->delete();

            return redirect()->route('admin.bets.clients.index')->withErrors([
                'success' => 'Cliente deletado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.clients.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar o cliente, tente novamente'
            ]);

        }
    }
}
