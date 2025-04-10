<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private $usuarios = [
        ['id' => 1, 'nome' => 'João Silva', 'email' => 'joao@example.com'],
        ['id' => 2, 'nome' => 'Maria Souza', 'email' => 'maria@example.com'],
        ['id' => 3, 'nome' => 'Carlos Oliveira', 'email' => 'carlos@example.com']
    ];

    public function index()
    {
        return response()->json($this->usuarios);
    }

    public function create()
    {
        return response()->json(['message' => 'Página de criação de usuário']);
    }

    public function store(Request $request)
    {
        $novoUsuario = [
            'id' => count($this->usuarios) + 1,
            'nome' => $request->input('nome'),
            'email' => $request->input('email')
        ];
        
        array_push($this->usuarios, $novoUsuario);
        return response()->json($novoUsuario, 201);
    }

    public function show($id)
    {
        $usuario = collect($this->usuarios)->firstWhere('id', $id);
        return $usuario ? response()->json($usuario) : response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    public function edit($id)
    {
        $usuario = collect($this->usuarios)->firstWhere('id', $id);
        return $usuario ? response()->json($usuario) : response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    public function update(Request $request, $id)
    {
        $usuarioIndex = collect($this->usuarios)->search(function ($usuario) use ($id) {
            return $usuario['id'] == $id;
        });

        if ($usuarioIndex !== false) {
            $this->usuarios[$usuarioIndex] = [
                'id' => $id,
                'nome' => $request->input('nome'),
                'email' => $request->input('email')
            ];
            return response()->json($this->usuarios[$usuarioIndex]);
        }

        return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    public function destroy($id)
    {
        $this->usuarios = array_filter($this->usuarios, function ($usuario) use ($id) {
            return $usuario['id'] != $id;
        });
        return response()->json(['message' => 'Usuário removido com sucesso']);
    }
}