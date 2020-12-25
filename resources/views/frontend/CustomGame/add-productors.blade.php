<div>
<div class="columns is-gapless mb-2">

    <div class="column is-10">

        <div class="field has-addons">
            <div class="control">
                <input class="input is-small" type="text" wire:model="newProductorValues.{{$position}}.value" name="productors[{{$position}}]">
            </div>

            <a class="button @if(isset($linkables[$position]) && $linkables[$position]) has-text-info @else has-text-light @endif is-small"
               wire:click="linkable({{$position}})"
            >
                <i class="fas fa-external-link-alt" ></i>
            </a>
            @if(isset($linkables[$position]) && $linkables[$position]) <input  type="hidden" name="productor_links[{{$position}}]">  @endif
        </div>
    </div>

    <div class="column is-1">
        @if (count($newProductors) == $position &&  isset($newProductorValues[$position]))
            <span class="icon is-small ml-1 has-text-info is-clickable" wire:click="addProductor">
          <i class="fas fa-plus-circle"></i>
        </span>
       @endif

       <span class="icon is-small ml-1 has-text-danger is-clickable" wire:click="removeProductor({{$position}})">
          <i class="fas fa-minus-circle"></i>
        </span>
    </div>
</div>
</div>
