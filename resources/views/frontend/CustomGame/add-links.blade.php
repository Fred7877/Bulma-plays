<div class="columns is-gapless mb-1">
<div class="column is-10">
    <input type="text" class="input is-small" wire:model="newLinkValues.{{$position}}.value" name="links[{{$position}}]">
</div>

<div class="column is-1">

    @if (count($newLinks) == $position && isset($newLinkValues[$position]))
        <span class="icon is-small ml-2 has-text-info is-clickable" wire:click="addLink">
          <i class="fas fa-plus-circle"></i>
        </span>
    @endif

    <span class="icon is-small ml-2 has-text-danger is-clickable" wire:click="removeLink({{$position}})">
          <i class="fas fa-minus-circle"></i>
        </span>
</div>
</div>
