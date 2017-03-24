<div class="form-inline pull-right-sm">

    <div class="form-group">
        <select id="filter" class="form-control input-sm" v-model="filter.tech" v-show="filter.type != 'tech'">
            <option value="2g">2G</option>
            <option value="3g">3G</option>
            <option value="4g">4G</option>
        </select>
    </div>

    <div class="form-group">
        <select id="filter" class="form-control input-sm" v-model="filter.vendor" v-show="filter.type != 'vnd'">
            <option value="eri">ERI</option>
            <option value="hua">HUA</option>
        </select>
    </div>

    <button type="button"
            class="btn btn-success btn-sm custom-btn"
            v-on:click.prevent="showCreateModal">
            <span class="glyphicon glyphicon-plus"></span> Add
    </button>

</div>