<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{ $attributes['title'] }}</h4>
                <div data-repeater-list="group-a">
                    <div class="row" data-repeater-item>


                        @forelse (app('abilities')[$attributes['rules_type']] as $ability_code => $ability_name)
                            <div class="mb-3 col-lg-2">
                                <div class="form-check">
                                    <input class="form-check-input checkbox-item" type="checkbox" value="allow"
                                        name="abilities[{{ $ability_code }}]" @checked(($attributes['rule_abilities'][$ability_code] ?? '') == 'allow')
                                        id="setting_{{ $ability_code }}">
                                    <label class="form-check-label fw-bold" for="setting_{{ $ability_code }}">
                                        {{ $ability_name }}
                                    </label>

                                </div>
                            </div>
                        @empty
                            <div>لا يوجد تصنيفات</div>
                        @endforelse

                    </div>
                    <!-- end row -->
                </div>

            </div>
        </div>
    </div>
</div>
