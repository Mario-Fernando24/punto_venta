<div class="card-body table-responsive p-0" style="height: 600px;">
                <br>
                <table class="table table-head-fixed">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>categoria</th>
                      <th>producto</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($articulos as $art)
                        <tr>
                          <td>{{ $art->id }}</td>
                        <td>{{ $art->categoria->nombre }}</td>   
                        <td>{{ $art->nombre }}</td>   

                    @endforeach
                    </tbody>
                </table>
            <!--PARA QUE NOS GUARDEN TODO LO QUE ESTA EN LA URL PARA QUE NO SE PIERDA LA BUSQUEDA-->
         
              </div>
            </div>