<?php

function admin()
{
    if (!session('adminSession.logado', false)) {
        throw new App\Exceptions\UserException('Você precisa estar logado para acessar essa página');
    }
    $admin = \App\Models\Admin\Admin::findOrFail(session('adminSession.id'));
    if ($admin) {
        return $admin;
    }
    throw new App\Exceptions\UserException('Houve um erro ao encontrar o usuário');
}

function adminLogged()
{
    if (session('adminSession.logado', false)) {
        $admin = App\Models\Admin\Admin::find(session('adminSession.id'));
        if ($admin->token === session('adminSession.token', false)) {
            return true;
        }
    }
    return false;
}