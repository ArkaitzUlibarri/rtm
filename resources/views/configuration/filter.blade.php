<div class="form-inline pull-right-sm">

    <div class="form-group">
        <select id="filter" class="form-control input-sm" v-model="filter.tech" v-show="filter.type != 'tech'">
            @foreach(config('filter.technologies') as $tech)
                <option value="{{ $tech }}">{{ strtoupper($tech) }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <select id="filter" class="form-control input-sm" v-model="filter.vendor" v-show="filter.type != 'vnd'">
            @foreach(config('filter.vendor') as $vendor)
                <option value="{{ $vendor }}">{{ strtoupper($vendor) }}</option>
            @endforeach
        </select>
    </div>

    <button type="button"
            class="btn btn-success btn-sm custom-btn"
            v-on:click.prevent="showCreateModal">
            <span class="glyphicon glyphicon-plus"></span> Add
    </button>

</div>