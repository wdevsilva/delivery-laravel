<?php

namespace App\Models;

class StatusModel
{
    public static function check($status)
    {
        $obj = new \stdClass;
        $pat = ['/1/', '/2/', '/3/', '/4/', '/5/', '/6/', '/7/', '/8/', '/9/'];
        $rep = [
            '<i class="fa fa-hourglass-o"></i> Pendente',
            '<i class="fa fa-hourglass-2"></i> Em Produção',
            '<i class="fa fa-motorcycle"></i>  Saiu para entrega',
            '<i class="fa fa-check-circle-o"></i> Entregue',
            '<i class="fa fa-remove"></i> Cancelado',
            '<i class="fa fa-check-circle-o"></i> Disponível para retirada',
            '<i class="fa fa-check-circle-o"></i> Aguardando Pagamento Pix',
            '<i class="fa fa-check-circle-o"></i> Pedido Agendado',
            '<i class="fa fa-check-circle-o"></i> Pronto Para Retirada',
        ];
        $txt = [
            'Pendente',
            'Em produção',
            'Saiu para entrega',
            'Entregue',
            'Cancelado',
            'Disponível para retirada',
            'Aguardando Pagamento Pix',
            'Pedido Agendado',
            'Pronto Para Retirada',
        ];
        $obj->icon = preg_replace($pat, $rep, $status);
        $pat = ['/1/', '/2/', '/3/', '/4/', '/5/', '/6/', '/7/', '/8/', '/9/'];
        $rep = ['warning', 'info', 'info', 'success', 'danger', 'success', 'warning', 'success', 'info'];
        $obj->color = preg_replace($pat, $rep, $status);
        $obj->text = preg_replace($pat, $txt, $status);
        return $obj;
    }

    public static function pagseguro($status)
    {
        $obj = new \stdClass;
        $pat = ['/0/', '/1/', '/2/', '/3/', '/4/', '/5/', '/6/', '/7/', '/8/', '/9/'];
        $rep = [
            '<i class="fa fa-money"></i> Não Utilizado',
            '<i class="fa fa-hourglass-o"></i> Aguardando pagamento',
            '<i class="fa fa-hourglass-2"></i> Em análise',
            '<i class="fa fa-check-circle-o"></i>  Pago',
            '<i class="fa fa-check-circle-o"></i> Disponível',
            '<i class="fa fa-remove"></i> Em disputa',
            '<i class="fa fa-remove"></i> Devolvida',
            '<i class="fa fa-remove"></i> Pagto Não Aprovado',
            '<i class="fa fa-check-circle-o"></i> Debitado',
            '<i class="fa fa-remove"></i> Retenção temporária',
        ];
        $txt = [
            'Não Utilizado',
            'Aguardando pagamento',
            'Em análise',
            'Pago',
            'Disponível',
            'Em disputa',
            'Devolvida',
            'Cancelada',
            'Debitado',
            'Retenção temporária',
        ];
        $obj->icon = preg_replace($pat, $rep, $status);
        $pat = ['/0/', '/1/', '/2/', '/3/', '/4/', '/5/', '/6/', '/7/', '/8/', '/9/'];
        $rep = ['', 'warning', 'info', 'success', 'success', 'danger', 'danger', 'danger', 'success', 'danger'];
        $obj->color = preg_replace($pat, $rep, $status);
        $obj->text = preg_replace($pat, $txt, $status);
        return $obj;
    }

    public static function checkStatusPix($status)
    {
        $obj = new \stdClass;

        $pat = [
            '/^pending$/',
            '/^approved$/',
            '/^rejected$/',
            '/^in_process$/',
            '/^cancelled$/',
            '/^expired$/',
        ];

        $repIcons = [
            '<i class="fa fa-hourglass-o"></i> Aguardando Pagamento',
            '<i class="fa fa-check-circle-o"></i> Pagamento Aprovado',
            '<i class="fa fa-times-circle"></i> Pagamento Rejeitado',
            '<i class="fa fa-refresh fa-spin"></i> Processando Pagamento',
            '<i class="fa fa-ban"></i> Pagamento Cancelado',
            '<i class="fa fa-clock-o"></i> Pagamento Expirado',
        ];

        $repColors = [
            'warning',   // pending
            'success',   // approved
            'danger',    // rejected
            'info',      // in_process
            'secondary', // cancelled
            'dark',      // expired
        ];

        $repTexts = [
            'Aguardando Pagamento',
            'Pagamento Aprovado',
            'Pagamento Rejeitado',
            'Processando Pagamento',
            'Pagamento Cancelado',
            'Pagamento Expirado',
        ];

        $obj->icon  = preg_replace($pat, $repIcons, $status);
        $obj->color = preg_replace($pat, $repColors, $status);
        $obj->text  = preg_replace($pat, $repTexts, $status);

        return $obj;
    }
}
