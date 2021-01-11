@extends('layouts.login')

@section('login')

<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
          <form class="form-horizontal was-validated" method="POST" action="{{ url('login') }}">
          @csrf
 
            <div class="card-body">
              <h1>TenderPos</h1>
              <p class="text-muted">Control de acceso a TenderPos</p>
              <div class="input-group mb-3 @error('usuario') is-invalid @enderror">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" name="usuario" value="{{old('usuario')}}"  id="usuario" class="form-control" placeholder="Usuario">
              </div>
              @if ($errors->has('usuario'))
               <span class="help-block">
                    <strong style="color:red">{{ $errors->first('usuario') }}</strong>
               </span>
             @endif 
           

              <div class="input-group mb-4 @error('password') is-invalid @enderror">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" value="{{old('password')}}" id="password" class="form-control" placeholder="Password">
              </div>
              @if ($errors->has('password'))
                <span class="help-block">
                        <strong style="color:red">{{ $errors->first('password') }}</strong>
                </span>
                @endif 

             @if( session('error'))
                <span class="help-block">
                    <strong style="color:red">{{ session('error') }}</strong>
               </span>
             @endif


              <div class="row">
                <div class="col-12">
                  <input type="submit" value="Acceder" class="btn  btn-outline-primary btn-block">
                </div>
                <div class="col-6 text-right">
                  <button type="button" class="btn btn-link px-0">Olvidaste tu password?</button>
                </div>
              </div>
            </div>
            </form>
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
