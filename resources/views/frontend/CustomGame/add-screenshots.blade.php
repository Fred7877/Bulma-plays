<div class="columns is-gapless mb-1">
    <div class="column is-10">
        <div class="file has-name is-small">
            <label class="file-label">
                <input class="file-input" type="file" wire:model="newScreenshotValues.{{$position}}.value"
                       name="screenshots[{{$position}}]" value="{{ $newScreenshotValues[$position]['value'] ?? '' }}">
                <input type="hidden"  value="{{ $newScreenshotValues[$position]['value'] ?? '' }}" name="screenshotsHidden[{{ $position }}]" >
                <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choose a file…
                        </span>
                    </span>
                <span class="file-name">
                     @if(isset($newScreenshotValues[$position]))
                        @if(!is_string($newScreenshotValues[$position]['value']))
                            {{ $newScreenshotValues[$position]['value']->getClientOriginalName() }}
                        @else
                            {{ basename($newScreenshotValues[$position]['value']) }}
                        @endif
                    @endif
                </span>
            </label>
        </div>
        @error('newScreenshotValues.'.$position.'.value') <div class="mt-1 p-1 is-size-7 has-text-danger has-background-danger-light">{{ $message }}</div> @enderror
    </div>
    <div class="column is-1">
        @if ($newScreenshotValues[$position]['value'] != '' && count($newScreenshotValues) == $position + 1)
            <span class="icon is-small ml-2 has-text-info is-clickable" wire:click="addScreenshot">
          <i class="fas fa-plus-circle"></i>
        </span>
        @endif
            <span class="icon is-small ml-2 has-text-danger is-clickable" wire:click="removeScreenshot({{$position}})">
          <i class="fas fa-minus-circle"></i>
        </span>
    </div>
</div>
