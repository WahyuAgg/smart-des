
<div class="d-flex justify-content-between">

    @foreach ($steps as $index => $step)

        <div class="text-center">

            <div class="step-circle
                {{ $noStep >= ($index + 1) ? 'active' : '' }}">

                {{ $index + 1 }}

            </div>

            <small>

                {{ $step }}

            </small>

        </div>

    @endforeach

</div>