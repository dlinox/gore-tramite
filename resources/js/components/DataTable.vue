<template>
    <slot name="header" :filter="formfilters"> </slot>
    <v-table class="mt-3 bg-">
        <thead>
            <tr>
                <th v-if="withAction && actionsStart" class="th-action">Acciones</th>
                <th
                    class="text-left th-data-table font-weight-bold"
                    v-for="(item, index) in headers"
                    :key="index"
                    @click="
                        !item.short
                            ? (item.short = true)
                            : item.order == 'DESC'
                            ? ((item.short = false), (item.order = 'ASC'))
                            : (item.order = 'DESC')
                    "
                >
                    <div class="d-flex justify-space-between align-center">
                        <small>{{ item.text.toUpperCase() }} </small>
                        <!-- <v-badge v-if="item.short" :content="1" color="black">
                            <v-btn
                                :icon="
                                    item.order == 'DESC'
                                        ? 'mdi-arrow-up'
                                        : 'mdi-arrow-down'
                                "
                                size="x-small"
                                variant="tonal"
                                color="gray"
                            />
                        </v-badge> -->
                    </div>
                </th>
                <th v-if="(withAction || actionsEnd) && !actionsStart" class="th-action">Acciones</th>
            </tr>
        </thead>

        <tbody>
            <template v-if="items.total == 0">
                <tr>
                    <td
                        :colspan="
                            withAction ? headers.length + 1 : headers.length
                        "
                    >
                        <NoData />
                    </td>

                    
                </tr>
            </template>
            <template v-else>
                <tr
                    v-for="item in items.data"
                    :key="item.name"
                    style="font-size: 14px"
                >
                    <template v-if="withAction && actionsStart">
                        <td>
                            <slot name="action" :item="item"> </slot>
                        </td>
                    </template>

                    <template v-for="(header, j) in headers">
                        <td>
                            <slot :name="'item.' + header.value" :item="item">
                                {{ item[header.value] }}
                            </slot>
                        </td>
                    </template>
                    <template v-if="(withAction || actionsEnd) && !actionsStart">
                        <td>
                            <slot name="action" :item="item"> </slot>
                        </td>
                    </template>
                </tr>
            </template>
        </tbody>
        <tfoot v-show="items.total > 0">
            <tr>
                <td
                    :colspan="
                        withAction || actionsStart || actionsStart
                            ? headers.length + 1
                            : headers.length
                    "
                >
                    <div class="d-flex justify-space-between align-center pt-3">
                        <div class="">
                            <v-select
                                v-model="formfilters.perPage"
                                label="Mostrar"
                                :clearable="false"
                                placeholder="10"
                                :items="[1, 5, 10, 50, 100, 500]"
                            />
                        </div>
                        <v-spacer></v-spacer>
                        <div class="">
                            <PaginationDataTable :items="items" />
                        </div>
                    </div>
                    <slot name="footer" :filter="formfilters"> </slot>
                </td>
            </tr>
        </tfoot>
    </v-table>
</template>

<script setup>
import { ref, watch } from "vue";
import PaginationDataTable from "@/components/PaginationDataTable.vue";
import NoData from "@/components/NoData.vue";
import { pickBy, throttle, debounce } from "lodash";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    headers: Array,
    items: Object,
    url: String,
    withAction: {
        type: Boolean,
        default: false,
    },

    actionsStart: {
        type: Boolean,
        default: false,
    },
    actionsEnd: {
        type: Boolean,
        default: false,
    },
});

const formfilters = ref({
    search: "",
    perPage: props.items.per_page,
});

watch(
    formfilters,
    debounce((val) => {
        router.get(props.url, pickBy(val), {
            preserveState: true,
        });
    }, 300),
    { deep: true }
);
</script>
<style lang="scss">
.th-data-table {
    &:hover {
        background-color: rgba(55, 55, 55, 0.04);
    }
}
.th-action {
    width: 150px;
}
</style>
