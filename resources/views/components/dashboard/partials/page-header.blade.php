
@props(['header', 'label_url','label'])
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $header }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{  $label_url ?? route("dashboard.home") }}">{{ $label ?? 'Dashboard' }}</a></li>
                    <li class="breadcrumb-item active">{{ $header }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
