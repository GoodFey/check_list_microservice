<template>
    <div class="container mt-5">
        <h2 class="mb-4">Редактирование чек-листа</h2>
        <form @submit.prevent="updateChecklist">
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
                    v-model="tagsInput"
                    class="form-control"
                    placeholder="Введите теги через запятую"
                />
            </div>

            <!-- Список пунктов с Drag-and-Drop -->
            <div class="mb-3">
                <label class="form-label">Пункты чек-листа</label>
                <VueDraggable ref="itemsList" v-model="checklist.items" :animation="200">
                    <div v-for="(item, index) in checklist.items" :key="item.item_id" class="list-item d-flex align-items-center">
                        <span class="drag-handle me-3">☰</span>
                        <input
                            type="text"
                            v-model="item.item_text"
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
            <button type="submit" class="btn btn-success">Обновить чек-лист</button>
        </form>
    </div>
</template>

<script>
import { VueDraggable } from "vue-draggable-plus";
import axios from "axios";
import apiClient from "../services/apiClient.js";

export default {
    components: { VueDraggable },
    data() {
        return {
            checklist: {
                name: "",
                isOnPublish: false,
                tags: [],
                items: [],
            },
            tagsInput: "", // Для отображения и редактирования тегов в виде строки
        };
    },
    methods: {
        async fetchChecklist() {
            try {
                const response = await apiClient.get(`/checklist/edit/${this.$route.params.checklistId}`)
                const data = response.data;

                // Инициализируем данные
                this.checklist = {
                    name: data.name,
                    isOnPublish: !!data.isOnPublish,
                    items: data.items,
                    tags: data.tags.map(tag => tag.tag_name),
                };

                // Преобразуем теги в строку для удобного редактирования
                this.tagsInput = this.checklist.tags.join(", ");
            } catch (error) {
                console.log(error);
            }
        },
        addItem() {
            const newItem = {item_id: Date.now(), item_text: ""};
            this.checklist.items.push(newItem);
        },
        removeItem(index) {
            this.checklist.items.splice(index, 1);
        },
        async updateChecklist() {
            try {
                // Преобразуем теги из строки в массив
                this.checklist.tags = this.tagsInput

                await apiClient.patch(`/checklist/update/${this.$route.params.checklistId}`, {
                    checklist: this.checklist,
                });

                this.$router.push({name: "index"});
            } catch (error) {
                console.log(error);
            }
        },
    },
    mounted() {
        this.fetchChecklist();
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
