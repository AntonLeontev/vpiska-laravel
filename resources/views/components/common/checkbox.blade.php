<div class="{{ $class ?? '' }}">
  <label class="check">
		<input class="check__input" 
			type="checkbox" 
			name="{{ $name }}"
			@checked($check ?? false)
			@disabled($disable ?? false)
		>
		<span class="check__box"></span>
		{{ $slot }}
	</label>	
</div>
