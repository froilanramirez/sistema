<div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            <li @click = "menu=0" class="nav-item">
              <a class="nav-link" href="#">
                <i class="nav-icon icon-speedometer"></i> Escritorio
                <!-- <span class="badge badge-primary">NEW</span> -->
              </a>
            </li>
            <li class="nav-title">Mantenimiento</li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-star"></i> Ventas</a>
                <ul class="nav-dropdown-items">
                  <li @click = "menu=5" class="nav-item">
                    <a class="nav-link" href="#">
                      <i class="nav-icon icon-star"></i> Ventas
                      <!-- <span class="badge badge-success">NEW</span> -->
                    </a>
                  </li>
                  <li @click = "menu=6" class="nav-item">
                    <a class="nav-link" href="#">
                      <i class="nav-icon icon-star"></i> Clientes</a>
                  </li>
                </ul>
              </li>
            
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dorpdown-toggle" href="#">
                <i class="nav-icon icon-calculator"></i> Reportes
                <!-- <span class="badge badge-primary">NEW</span> -->
              </a>
              <ul class="nav-dropdown-items">
                <li @click = "menu=10" class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="nav-icon icon-bell"></i> Reporte Ventas</a>
                </li>
              </ul>
            </li>
            <li @click = "menu=11" class="nav-item">
              <a class="nav-link" href="#">
                <i class="nav-icon icon-pie-chart"></i> Ayuda</a>
            </li>
            <li @click = "menu=12" class="nav-item">
              <a class="nav-link" href="#">
                <i class="nav-icon icon-pie-chart"></i> Acerca de ...</a>
            </li>
          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>