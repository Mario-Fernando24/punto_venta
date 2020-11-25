@extends('layouts.login')

@section('login')

<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <div class="card-body">
              <h1>TenderPos</h1>
              <p class="text-muted">Control de acceso a TenderPos</p>
              <div class="input-group mb-3">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
              </div>
              <div class="input-group mb-4">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="clave" id="clave" class="form-control" placeholder="Password">
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="button" class="btn btn-primary px-4">Acceder</button>
                </div>
                <div class="col-6 text-right">
                  <button type="button" class="btn btn-link px-0">Olvidaste tu password?</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2> TenderPos</h2>
                <p><b>TenderPos</b> no solo te ayudará a agilizar tus ventas, 
                también te aportará la opción de poder controlar tu inventario en tiempo real.
                 De esta forma, evitas hacer un conteo manual o tener que trasladarte físicamente a tu 
                 almacén para conocer la cantidad de productos disponibles.</p>
                <a href="" target="_blank" class="btn btn-primary active mt-3">Ayuda!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
