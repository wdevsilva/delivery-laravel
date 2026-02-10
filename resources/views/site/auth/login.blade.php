@extends('layouts.site')

@section('content')
@php
@session_start();
$isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
@endphp

<div class="container" id="home-content">
    <form action="{{ url('/cliente-login-entrar') }}{{ $fromCarrinho ? '?carrinho=1' : '' }}" method="post" role="form" autocomplete="off">
        @csrf
        <div class="{{ !$isMobile ? 'col-md-offset-2 col-md-8' : '' }}" style="background-color: rgba(255, 255, 255, 0.5);">
            <div class="form-group">
                <hr>
                <label for="cliente_fone">Digite o número do seu celular</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                    <input type="tel" name="cliente_fone" id="cliente_fone" class="form-control" data-mask="cell" placeholder="(99) 99999-9999" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">
                    <i class="fa fa-check-circle-o"></i>
                    CONTINUAR
                </button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(function() {
        // Máscara de telefone
        $('#cliente_fone').mask('(99) 99999-9999');

        @if(session('error'))
            $.gritter.add({
                time: 2000,
                position: 'center',
                title: 'Erro',
                text: '{{ session('error') }}',
                class_name: 'danger'
            });
        @endif

        @if(session('success'))
            $.gritter.add({
                title: 'Sucesso',
                text: '{{ session('success') }}',
                class_name: 'success'
            });
        @endif
    });
</script>
@endsection
