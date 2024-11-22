<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a class="brand-link" href="{{ route('admin.dashboard.show') }}">
		<img class="brand-image img-circle elevation-3" src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" style="opacity: .8">
		<span class="brand-text font-weight-bold" style="font-family: Cairo">لوحة الإدارة</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img class="img-circle elevation-2" src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" alt="User Image">
			</div>
			<div class="info">
				<a class="d-block" href="#">{{ getUserName(auth()->user()->id) }}</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false" role="menu">

				<li class="nav-item {{ request()->is('admin/dashboard') || request()->is('admin/admins/*') ? 'menu-open' : '' }}">
					<a class="nav-link active" href="#">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							لوحة العرض
							<i class="fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('home.index') }}">
								<i class="fa fa-home nav-icon"></i>
								<p> الرئيسية </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/admins/home') ? 'active' : '' }}" href="{{ route('setting.home') }}">
								<i class="fa fa-home nav-icon"></i>
								<p> الضبط العام </p>
							</a>
						</li>

					</ul>
				</li>

				{{-- ----------------------- Accounts ---------------------------- --}}

				<li class="nav-item has-treeview {{ request()->is('admin/accounts/*') || request()->is('admin/treasuries/*') ? 'menu-open' : '' }}">
					<a class="nav-link active" href="#">
						<i class="nav-icon fa fa-th"></i>
						<p>
							الحسابات العامة
							<i class="fas fa-angle-left"></i>
						</p>
					</a>

					<ul class="nav nav-treeview">

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/accounts/home') ? 'active' : '' }}" href="{{ route('accounts.home') }}">
								<i class="fa fa-home nav-icon"></i>
								<p> الرئيسية </p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/accounts/cats/home') ? 'active' : '' }}" href="{{ route('accounts.cats.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p>تصنيفات الحسابات</p>
							</a>

						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/accounts/types/home') ? 'active' : '' }}" href="{{ route('accounts.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p>طبيعة الحسابات</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/accounts/setting') || request()->is('admin/accounts/setting/*') ? 'active' : '' }}"
								href="{{ route('accounts.setting') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p>إعدادات المحاسبة</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/treasuries') || request()->is('admin/treasuries/*') ? 'active' : '' }}"
								href="{{ route('treasuries.home') }}">
								<i class="nav-icon fa fa-ban" aria-hidden="true"></i>
								<p>
									الخــــزن
									{{-- <span class="right badge badge-danger">New</span> --}}
								</p>
							</a>
						</li>
					</ul>
				</li>

				{{-- --------------------- Store --------------------------------- --}}
				<li
					class="nav-item {{ request()->is('admin/storeArray/*') ||
					request()->is('admin/box/size/*') ||
					request()->is('admin/storeItems/*') ||
					request()->is('admin/stores/*') ||
					request()->is('admin/sections/*') ||
					request()->is('admin/rooms/*') ||
					request()->is('admin/tables/*')
					    ? 'menu-open'
					    : '' }}">
					<a class="nav-link active" href="#">
						<i class="nav-icon fa fa-th"></i>
						<p>
							التخزين
							<i class="fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/stores/home') ? 'active' : '' }}" href="{{ route('stores.home') }}">
								<i class="fa fa-home nav-icon"></i>
								<p>الرئيسية</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/sections/home') ? 'active' : '' }}" href="{{ route('sections.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الأقسام </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/rooms/home') ? 'active' : '' }}" href="{{ route('rooms.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الغرف </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/tables/*') ? 'active' : '' }}" href="{{ route('tables.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الطبليات</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/stores/items/*') ? 'active' : '' }}" href="{{ route('store.items.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> اسماء الأصناف</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/stores/items/categories/*') ? 'active' : '' }}" href="{{ route('store-items-categories-list') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> فئات الأصناف</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/stores/items/grades/*') ? 'active' : '' }}" href="{{ route('store-items-grades-list') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> درجات الأصناف</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/box/size/*') ? 'active' : '' }}" href="{{ route('box.size.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> احجام الكرتون </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/stores/settings/*') ? 'active' : '' }}" href="{{ route('store.settings') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p>الضبط</p>
							</a>
						</li>

					</ul>
				</li>

				{{-- The application Clients --}}

				<li
					class="nav-item {{ request()->is('admin/clients/*') || request()->is('admin/clients_settings/*') || request()->is('admin/contacts/*') || request()->is('admin/clientsCategories/*') ? 'menu-open' : '' }}">
					<a class="nav-link active" href="#">
						<i class="nav-icon fa fa-th"></i>
						<p>
							العملاء
							<i class="fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/clients/*') ? 'active' : '' }}" href="{{ route('clients.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> قائمة العملاء </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/contacts/*') ? 'active' : '' }}" href="{{ route('contacts.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> جهات الاتصال </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/clientsCategories/*') ? 'active' : '' }}" href="{{ route('clientsCategories.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> تصنيفات العملاء </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('clients/reports/*') ? 'active' : '' }}" href="{{ route('clients.reports.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> تقارير العملاء </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/clients_settings/*') ? 'active' : '' }}" href="{{ route('clients.settings') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الضبط </p>
							</a>
						</li>

					</ul>
				</li>

				{{-- The application purchases --}}
				<li class="nav-item">
					<a class="nav-link active" href="#">
						<i class="nav-icon fa fa-th"></i>
						<p>
							المشتريات
							<i class="fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link" href="{{ route('vendors.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الموردين </p>
							</a>
						</li>

					</ul>
				</li>

				{{-- ----------------------- Sales ------------------------------- --}}
				<li
					class="nav-item {{ request()->is('admin/sales/*') || request()->is('admin/items/*') || request()->is('admin/contracts/*') ? 'menu-open' : '' }}">
					<a class="nav-link active" href="#">
						<i class="nav-icon fa fa-th"></i>
						<p>
							المبيعات
							<i class="fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/sales/*') ? 'active' : '' }}" href="{{ route('sales.itemsCategories') }}">
								<i class="fa fa-home nav-icon"></i>
								<p>الاحصائيات</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/contracts/*') ? 'active' : '' }}" href="{{ route('contracts.index') }}">
								<i class="fa fa-home nav-icon"></i>
								<p>العقود</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/items/*') ? 'active' : '' }}" href="{{ route('items.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p>المنتجات والخدمات</p>
							</a>
						</li>
					</ul>
				</li>

				{{-- ----------------------- Movements ------------------------------- --}}

				<li
					class="nav-item {{ request()->is('admin/delivery/*') || request()->is('admin/operating/*') || request()->is('admin/arrange/*') || request()->is('admin/reception/*') ? 'menu-open' : '' }}">
					<a class="nav-link active" href="#">
						<i class="nav-icon fa fa-th"></i>
						<p>
							التشغـــــــــــيل
							<i class=" fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/operating/home') ? 'active' : '' }}" href="{{ route('operating.home') }}">
								<i class="fa fa-home nav-icon"></i>
								<p> الرئيسية </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/receipts/all/*') ? 'active' : '' }}" href="{{ route('receipts.all', [1]) }}">
								<i class="fa fa-home nav-icon"></i>
								<p> السندات </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/reception/*') ? 'active' : '' }}" href="{{ route('reception.home', [1]) }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> استقبال البضاعة</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/delivery/*') ? 'active' : '' }}" href="{{ route('delivery.home', [1]) }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> إخراج البضاعة </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/arrange/*') ? 'active' : '' }}" href="{{ route('arrange.home', [1]) }}">
								<i class="fa fa-home nav-icon"></i>
								<p> ترتيب بضاعة </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/arrange/*') ? 'active' : '' }}" href="{{ route('position.home') }}">
								<i class="fa fa-home nav-icon"></i>
								<p> ترتيب مخزن </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/inventory/*') ? 'active' : '' }}" href="{{ route('operating.inventory.receipts', [1]) }}">
								<i class="fa fa-home nav-icon"></i>
								<p> سندات التسوية </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link  {{ request()->is('admin/receipts/receipts/*') ? 'active' : '' }}" href="{{ route('operating.receipts.log') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> سجل الحركات المحذوفة </p>
							</a>
						</li>

					</ul>
				</li>

				{{-- The application users --}}

				<li
					class="nav-item {{ request()->is('admin/users/*') || request()->is('admin/menues/*') || request()->is('admin/roles/*') || request()->is('admin/permissions/*') || request()->is('admin/drivers/*') ? 'menu-open' : '' }}">
					<a class="nav-link active" href="#">
						<i class="nav-icon fa fa-th"></i>
						<p>
							الاعدادات
							<i class="fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/users/*') ? 'active' : '' }}" href="{{ route('users.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الموارد البشرية </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="{{ route('users.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p style="white-space: wrap"> الوظائف

									{{-- $user->hasRole('admin')- --}}
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('files.gallery', [0]) }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الملفات </p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/drivers/*') ? 'active' : '' }}" href="{{ route('drivers.home') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> السائقين </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/menues/*') ? 'active' : '' }}" href="{{ route('display-menues-list') }}">
								<i class="fa fa-home nav-icon"></i>
								<p>القوائم الرئيسية</p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/permissions/*') ? 'active' : '' }}" href="{{ route('display-permissions-list') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الصلاحيات </p>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {{ request()->is('admin/roles/*') ? 'active' : '' }}" href="{{ route('display-roles-list') }}">
								<i class="fa fa-tag nav-icon"></i>
								<p> الأدوار </p>
							</a>
						</li>

					</ul>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
