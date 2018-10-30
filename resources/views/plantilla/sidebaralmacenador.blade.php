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
                <i class="nav-icon icon-puzzle"></i> Almacén</a>
              <ul class="nav-dropdown-items">
                <li @click = "menu=1" class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="nav-icon icon-puzzle"></i> Categorías</a>
                </li>
                <li @click = "menu=2" class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="nav-icon icon-puzzle"></i> Artículos</a>
                </li>
              </ul>
            </li> 
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-cursor"></i> Compras</a>
              <ul class="nav-dropdown-items">
                <li @click = "menu=3" class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="nav-icon icon-cursor"></i> Ingresos</a>
                </li>
                <li @click = "menu=4" class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="nav-icon icon-cursor"></i> Proveedores</a>
                </li>
              </ul>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dorpdown-toggle" href="#">
                <i class="nav-icon icon-calculator"></i> Reportes
                <!-- <span class="badge badge-primary">NEW</span> -->
              </a>
              <ul class="nav-dropdown-items">
                <li @click = "menu=9" class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="nav-icon icon-bell"></i> Reporte Ingresos</a>
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