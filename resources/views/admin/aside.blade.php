<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-start me-2">
                    <img src="/admin/img/photo.jpg" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a>
                        <span>
                            {{ $AdminName }}
                            <span class="user-level">Administrator</span>
                        </span>
                    </a>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.collection') }}">
                        <i class="fa fa-object-group"></i>
                        <p>Collection</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.stock.view') }}">
                        <i class="fas fa-box-open"></i>
                        <p>Stock</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manage_queries">
                        <i class="fas fa-question-circle"></i>
                        <p>Overview</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#specification">
                        <i class="fas fa-pen-square"></i>
                        <p>Properties</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="specification">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.colors') }}">
                                    <span class="sub-item">Colors</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.sizes') }}">
                                    <span class="sub-item">Size Chart</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#tables">
                        <i class="fas fa-table"></i>
                        <p>Tables</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="tables/tables.html">
                                    <span class="sub-item">Basic Table</span>
                                </a>
                            </li>
                            <li>
                                <a href="tables/datatables.html">
                                    <span class="sub-item">Datatables</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#maps">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Maps</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="maps">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="maps/jqvmap.html">
                                    <span class="sub-item">JQVMap</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item bg-grey">
                    <a href="download_backup">
                        <i class="fas fa-download"></i>
                        <p>Download Backup</p>
                        <span class=""></span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var currentUrl = window.location.href;
        $('.nav-item a').each(function() {
            var $this = $(this);
            var linkHref = $this.attr('href');

            if (currentUrl.includes(linkHref)) {
                $this.closest('.nav-item').addClass('active');
            }
        });
    });
</script>
