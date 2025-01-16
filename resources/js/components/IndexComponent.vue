<template>
    <div class="container mt-5">
        <h1 class="mb-4">Список чек-листов</h1>
        <div v-if="loading" class="text-center">
            <p>Загрузка...</p>
        </div>
        <div v-else>
            <div v-if="checklists.length === 0" class="text-center">
                <p>Чек-листы отсутствуют</p>
            </div>
            <div v-else>
                <div
                    v-for="checklist in checklists"
                    :key="checklist.check_list_id"
                    class="card mb-3"
                >
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">{{ checklist.name }}</h5>

                            </div>
                            <div class="col-1 ms-auto me-3">
                                <button @click.prevent="editChecklist(checklist.check_list_id)" class="btn btn-primary">Edit</button>

                            </div>
                        </div>
                        <p class="card-text">
                            <strong>Теги:</strong>
                            <span v-if="checklist.tags.length">
                                {{ checklist.tags.map(tag => tag.tag_name).join(', ') }}
                            </span>
                            <span v-else>Нет тегов</span>
                        </p>
                        <ul class="list-group">
                            <li
                                v-for="(item, index) in checklist.items"
                                :key="item.item_id || index"
                                class="list-group-item"
                            >
                                {{ item.item_text }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'IndexComponent',
    data() {
        return {
            checklists: [], // Привели к одному названию
            loading: false,
        };
    },
    computed: {
        formattedTags() {
            if (!this.checklist.tags) return null;

            return {}
        },
    },
    methods: {
        async getCheckLists() {
            try {
                this.loading = true;
                const response = await axios.get('api/checklist');
                if (Array.isArray(response.data)) {
                    this.checklists = response.data.map((checklist) => ({
                        ...checklist,
                        tags: checklist.tags || [], // Обработка отсутствующих тегов
                        items: checklist.items || [], // Обработка пустых пунктов
                    }));
                } else {
                    console.error('Unexpected API response format:', response.data);
                    this.checklists = [];
                }
            } catch (error) {
                console.error('Ошибка при загрузке чек-листов:', error);
                this.checklists = []; // Установить пустое значение в случае ошибки
            } finally {
                this.loading = false;
            }
        },
        editChecklist (checklistId) {
            this.$router.push({name: 'edit', params: {checklistId: checklistId}})
        }
    },
    mounted() {
        this.getCheckLists();
    },
};
</script>
