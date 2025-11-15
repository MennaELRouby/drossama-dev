<script>
    @if(session()->has('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session()->has('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    @if(session()->has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if(session()->has('info'))
        toastr.info("{{ session('info') }}");
    @endif
</script>
