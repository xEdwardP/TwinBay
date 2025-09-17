<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="{{ $icon }}"></i>&nbsp;{{ $title }}
                </h1>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0">
                        @foreach ($breadcrumbs as $crumb)
                            @if (isset($crumb['route']))
                                <li class="breadcrumb-item">
                                    <a href="{{ route($crumb['route']) }}">{{ $crumb['label'] }}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $crumb['label'] }}
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
