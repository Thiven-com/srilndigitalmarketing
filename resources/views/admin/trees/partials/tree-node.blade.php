<div class="tree-node">

    <a
        href="{{ route('admin.trees.index', [
            'tree' => $treeType,
            'user' => $node['userId'],
            'package_id' => $packageId
        ]) }}"
        class="tree-user-link"
    >

        <div class="tree-user">

            <div class="user-id">
                {{ $node['userId'] ?? '-' }}
            </div>

            <div class="customer-id">
                {{ $node['customer_name'] ?? '-' }}
            </div>

            @if(!empty($node['placedunder_id']))

                <div class="position">

                    Placed Under:
                    {{ $node['placedunder_id'] }}

                </div>

            @endif

            {{-- <div class="children-count">

                Children:
                {{ $node['placedunderid_cnt'] ?? 0 }}

            </div> --}}

        </div>

    </a>


    @if(!empty($node['children']))

        <div class="tree-children">

            @foreach($node['children'] as $child)

                @if($child)

                    @include(
                        'admin.trees.partials.tree-node',
                        [
                            'node' => $child,
                            'treeType' => $treeType
                        ]
                    )

                @endif

            @endforeach

        </div>

    @endif

</div>