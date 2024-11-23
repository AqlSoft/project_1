<div class="main-sidebar flex-shrink-0" style="width: 220px;">
    <a href="/"
        class="sidebar-brand d-flex align-items-center pb-1 mb-1 link-body-emphasis text-decoration-none border-bottom">
        <img class="bi pe-none me-2" src="{{ asset('assets/admin/uploads/images/ayerp.logo.png') }}" width="30"
            height="30">
        <span class="fs-5 fw-semibold">AYERP Home</span>
    </a>
    <span class="sidebar-toggle"><i class="fa fa-bars"></i></span>
    <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center collapsed" data-bs-toggle="collapse"
                data-bs-target="#home-collapse" aria-expanded="true">
                Store
            </button>
            <div class="collapse show" id="home-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/admin/stores/home"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">
                            <i class="fa fa-home"></i> &nbsp;
                            Home</a>
                    </li>

                    <li><a href="/admin/items/index"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">
                            <i class="fa fa-tags"></i> &nbsp; Items</a>
                    </li>

                    <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">
                            <i class="fa fa-tags"></i> &nbsp;Categories</a>
                    </li>

                    <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">
                            <i class="fa fa-weight-hanging"></i> &nbsp;Units</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center collapsed" data-bs-toggle="collapse"
                data-bs-target="#dashboard-collapse" aria-expanded="false">
                Dashboard
            </button>
            <div class="collapse" id="dashboard-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a>
                    </li>
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Weekly</a>
                    </li>
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Monthly</a>
                    </li>
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Annually</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center collapsed" data-bs-toggle="collapse"
                data-bs-target="#orders-collapse" aria-expanded="false">
                Orders
            </button>
            <div class="collapse" id="orders-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">New</a>
                    </li>
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Processed</a>
                    </li>
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Shipped</a>
                    </li>
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Returned</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center collapsed" data-bs-toggle="collapse"
                data-bs-target="#account-collapse" aria-expanded="false">
                Account
            </button>
            <div class="collapse" id="account-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">New...</a>
                    </li>
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Profile</a>
                    </li>
                    <li><a href="#"
                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Settings</a>
                    </li>
                    <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Sign
                            out</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
