<div class="notification-panel pe-3" id="pushNotificationArea">
    <button class="dropdown-toggle">
        <i class="fal fa-bell"></i>
        <sup><span class="count" v-cloak>@{{items.length}}</span></sup>
    </button>
    <ul class="notification-dropdown">
        <div class="dropdown-box" v-if="items.length > 0">
            <li>
                <a v-for="(item, index) in items" @click.prevent="readAt(item.id, item.description.link)" class="dropdown-item px-3" href="javascript:void(0)">
                    <i class="fal fa-bell"></i>
                    <div>
                        <p v-cloak v-html="item.description.text"></p>
                        <span v-cloak>@{{ item.formatted_date }}</span>
                    </div>
                </a>
            </li>
        </div>

        <div class="clear-all fixed-bottom">
            <a href="javascript:void(0)" v-if="items.length == 0">@lang('You have no notifications')</a>
            <a href="javascript:void(0)" v-if="items.length > 0" @click.prevent="readAll">@lang('Clear all')</a>
        </div>
    </ul>
</div>

