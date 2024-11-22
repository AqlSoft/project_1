{{-- {{ $aj_role }} --}}

<h5 class="text-right">{{ $aj_role->display_name_ar }}</h5>
<div class="input-group mt-3">
    <input type="hidden" name="role_id" value="{{ $aj_role->id }}">

</div>

<div class="accordion mt-4" id="adminsRolesPermissionsAccordion">
    @foreach ($aj_menues as $menu)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse_{{ $menu->id }}" aria-expanded="false"
                    aria-controls="collapse_{{ $menu->id }}">
                    {{ $menu->name }}
                </button>
            </h2>
            <div id="collapse_{{ $menu->id }}" class="accordion-collapse collapse"
                data-bs-parent="#adminsRolesPermissionsAccordion">
                <div class="accordion-body">
                    @foreach ($menu->permissions as $permission)
                        <div class="form-check form-switch form-check-reverse">
                            <input class="form-check-input" type="checkbox" name="permissions[]" role="switch"
                                id="permission_{{ $permission->id }}" value="{{ $permission->id }}"
                                {{ $aj_role->hasPermission($permission->id) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="permission_{{ $permission->id }}">{{ $permission->display_name_ar }}-
                                {{ $aj_role->hasPermission($permission->id) ? 'checked' : 'Not' }} - id = [
                                {{ $permission->id }} ]</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
