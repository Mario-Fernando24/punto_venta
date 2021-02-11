<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                   
                    <li class="nav-title">
                        @if(Auth::user()->idrol==1)
                         Admin {{Auth::user()->usuario}} 
                         @endif

                         @if(Auth::user()->idrol==2)
                         Vendedor {{Auth::user()->usuario}} 
                         @endif

                         @if(Auth::user()->idrol==3)
                         Bodeguero {{Auth::user()->usuario}} 
                         @endif

                    </li>


                    <li @click="menu=0" class="nav-item" >
                        <a class="nav-link active" href="#"><i class="icon-home"></i> Escritorio</a>
                    </li>

                    
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> Venta</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=5" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Facturar</a>
                            </li>
                            <li @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-group"></i> Clientes</a>
                            </li>
                        </ul>
                    </li>
                    


                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> Compras</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=3" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Ingresos</a>
                            </li>
                            <li @click="menu=4" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i> Proveedores</a>
                            </li>
                        </ul>
                    </li>

                    
                    


                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Bodega</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Categorías</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Artículos</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Ajuste de inventario</a>
                            </li>
                        </ul>
                    </li>

                    
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i>Documento de caja</a>
                        <ul class="nav-dropdown-items">

                        <li @click="menu=9" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-credit-card"></i>Egreso (-)</a>
                            </li>

                            
                            <li @click="menu=10" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-credit-card"></i>Ingreso (+)</a>
                            </li>


                        </ul>
                    </li>


                    <li @click="menu=12" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-money"></i>Movimiento de Caja</a>
                    </li>


                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Informes</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=16" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> Facturas Anuladas</a>
                            </li>

                            
                            
                            <li  class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i>Historial por cliente</a>
                            </li>
                            
                            <li  class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i>Historial de venta por producto</a>
                            </li>
                            <li  class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i>Historial de venta por categoria</a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Roles</a>
                            </li>
                        </ul>
                    </li>




                    
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>