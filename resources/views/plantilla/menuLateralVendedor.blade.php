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
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> Facturar</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=5" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Facturar</a>
                            </li>
                            <li @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i> Clientes</a>
                            </li>
                        </ul>
                    </li>
<!--
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Reportes</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=10" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ventas</a>
                            </li>
                        </ul>
                    </li>
                    -->


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




                    <li @click="menu=24" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Pendientes Cabas</a>
                            </li>


                <!--    <li @click="menu=11" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Ayuda <span class="badge badge-danger">PDF</span></a>
                    </li>
                    <li @click="menu=12" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
                    </li>

                    -->
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>