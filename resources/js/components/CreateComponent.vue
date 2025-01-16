<template>
    <div class="container mt-5">
        <h2 class="mb-4">Создание чек-листа</h2>
        <form @submit.prevent="saveChecklist">
            <!-- Название чек-листа -->
            <div class="mb-3">
                <label for="checklistName" class="form-label">Название чек-листа</label>
                <input
                    type="text"
                    id="checklistName"
                    v-model="checklist.name"
                    class="form-control"
                    placeholder="Введите название"
                />
            </div>

            <!-- Теги чек-листа -->
            <div class="mb-3">
                <label for="tags" class="form-label">Теги</label>
                <input
                    type="text"
                    id="tags"
                    v-model="checklist.tags"
                    class="form-control"
                    placeholder="Введите теги через запятую"
                />
            </div>

            <!-- Список пунктов с Drag-and-Drop -->
            <div class="mb-3">
                <label class="form-label">Пункты чек-листа</label>
                <VueDraggable ref="itemsList" v-model="checklist.items" :animation="200">
                    <div v-for="(item, index) in checklist.items" :key="item.id" class="list-item d-flex align-items-center">
                        <span class="drag-handle me-3">☰</span>
                        <input
                            type="text"
                            v-model="item.text"
                            class="form-control me-3"
                            placeholder="Введите пункт"
                        />
                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            @click="removeItem(index)"
                        >
                            Удалить
                        </button>
                    </div>
                </VueDraggable>
                <button type="button" class="btn btn-primary mt-3" @click="addItem">
                    Добавить пункт
                </button>
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" id="isOnPublish"
                           v-model="checklist.isOnPublish">
                    <label class="form-check-label" for="isOnPublish">Опубликовать?</label>
                </div>
            </div>

            <!-- Кнопка сохранения -->
            <button type="submit" class="btn btn-success">Сохранить чек-лист</button>
        </form>
    </div>
</template>

<script>
import { VueDraggable } from "vue-draggable-plus";
import axios from "axios";

export default {
    components: { VueDraggable },
    data() {
        return {
            checklist: {
                name: "",
                isOnPublish: false,
                tags: "",
                items: [
                    { id: 1, text: "Пример пункта 1" },
                    { id: 2, text: "Пример пункта 2" },
                ],

            },
        };
    },
    methods: {
        addItem() {
            const newItem = { id: Date.now(), text: "" };
            this.checklist.items.push(newItem);
        },
        removeItem(index) {
            this.checklist.items.splice(index, 1);
        },
        async saveChecklist() {
            try {
                await axios.post('api/checklist', {
                    'checklist': this.checklist
                })
                this.$router.push({name: 'index'})
            } catch (error) {
                console.log(error)
            }

        },
    },
};
</script>

<style>
.list-item {
    padding: 10px;
    margin: 5px 0;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    cursor: grab;
}

.list-item:active {
    cursor: grabbing;
}

.drag-handle {
    cursor: grab;
}
</style>
