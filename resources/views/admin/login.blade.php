@extends('admin.adminmasterlayout')

@section('title', 'Main - Admin Cooking Point')
@section('description', 'Cooking Point Admin Main Page')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/checklogin') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="redir" value="{{ $redir ? $redir :  url('/admin') }}">

                    <table class="table">
                        <tr>
                            <td class="">
                                Usuario:
                            </td>
                            <td class="">
                                <input type="text" name="name" >
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                Constraseña:
                            </td>
                            <td class="">
                                <input type="text" name="password" >
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop