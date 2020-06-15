
@if (session()->has('notify.message'))

    @if (session()->get('notify.model') === 'toast')
        <div class="notify-alert notify-{{ session()->get('notify.type') }} {{ config('notify.theme') }} animated {{ config('notify.animate.in_class') }}" role="alert">
            <div class="notify-alert-icon"><i class="fa fa-newspaper-o"></i></div>
            <div class="notify-alert-text">
                <h4>{{ session()->get('notify.title') ?? session()->get('notify.type') }}</h4>
                <p>{{ session()->get('notify.message') }}</p>
            </div>
            <div class="notify-alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
            </div>
        </div>
    @endif
@endif

@if(app()->getLocale()=='ar')
    <script>

        var notify = {
            timeout: "{{ config('notify.animate.timeout') }}",
            animatedIn: "{{ config('notify.animate.in_class') }}",
            animatedOut: "{{ config('notify.animate.out_class') }}",
            position: "bottom-right"

        }

    </script>
@else
    <script>

        var notify = {
            timeout: "{{ config('notify.animate.timeout') }}",
            animatedIn: "{{ config('notify.animate.in_class') }}",
            animatedOut: "{{ config('notify.animate.out_class') }}",
            position: "bottom-left"

        }

    </script>
@endif


{{--            @if (session()->has('msg'))--}}
{{--                @if(session()->get('type')=='success')--}}
{{--                    <div class="alert alert-success">--}}
{{--                        <p>  <i class="fa fa-check"></i> @lang(session()->get('msg'))</p>--}}
{{--                    </div>--}}
{{--                 --}}

{{--                @else--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <p>  <i class="fa fa-times"></i> @lang(session()->get('msg'))</p>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            @endif--}}
