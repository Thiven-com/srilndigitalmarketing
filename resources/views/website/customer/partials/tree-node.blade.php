<div class="tree-node">

    {{-- Current User --}}

    <div class="tree-user">

        {{-- User ID --}}

        <div class="user-id">

            {{ $node['userId'] }}

        </div>


        {{-- Customer ID --}}

        <div class="placed-under">

            Customer ID:

            {{ $node['customer_id'] }}

        </div>


        {{-- Sponsor --}}

        <div class="placed-under">

            Sponsor:

            {{ $node['sponser_id'] ?? '-' }}

        </div>


        {{-- Placed Under --}}

        <div class="placed-under">

            Placed Under:

            {{ $node['placedunder_id'] ?? '-' }}

        </div>

    </div>


    {{-- Children --}}

    @if(!empty($node['children']))

        <div class="tree-children">

            @foreach($node['children'] as $child)

                @if($child)

                    @include(
                        'website.customer.partials.tree-node',
                        [
                            'node' => $child
                        ]
                    )

                @endif

            @endforeach

        </div>

    @endif

</div>