@extends('empresa.template')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{$empresa->name}}<small>Clientes</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Clientes</li>
            <li class="active">Novo</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <form method="post" action="/{{$empresa->link}}/clientes/novo">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txNome">Nome</label>
                                <input type="text" class="form-control" id="txNome" name="txNome" placeholder="Nome" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txEmail">Email</label>
                                <input type="email" class="form-control" id="txEmail" name="txEmail" placeholder="Email" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="psSenha">CPF/CNPJ</label>
                                <input type="text" class="form-control" id="txDocumento" name="txDocumento" placeholder="Senha" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="dvAddEndereco" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-endereco">Adicionar Endereço</div>
                        </div>
                    </div>
                    @include('empresa.clientes.modalendereco')
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblEnderecos" class="table table-bordered">
                                <tr><th colspan="8" style="text-align: center">Endereços</th></tr>
                                <tr><th>Cep</th><th>Endereço</th><th>Número</th><th>Complemento</th><th>Bairro</th><th>Cidade</th><th>Estado</th><th></th></tr>
                            </table>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="dvAddTelefone" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-telefone">Adicionar Telefone</div>
                        </div>
                    </div>
                    @include('empresa.clientes.modaltelefone')
                    <div class="row">
                        <div class="col-md-6">
                            <table id="tblTelefones" class="table table-bordered">
                                <tr><th colspan="3" style="text-align: center">Telefones</th></tr>
                                <tr><th>DDD</th><th>Número</th><th>Ramal</th></tr>
                            </table>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-success btn-sm" value="Salvar"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@stop