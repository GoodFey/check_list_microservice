<template>
    <div class="container mt-5">
        <h1 class="mb-4">Список чек-листов</h1>

        <!-- Загрузка -->
        <div v-if="loading" class="text-center">
            <p>Загрузка...</p>
        </div>

        <!-- Таблица чек-листов -->
        <table v-else class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Пользователь</th>
                <th>Название</th>
                <th>Теги</th>
                <th>Элементы</th>
                <th>Публикация</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(checklist, index) in formattedChecklists" :key="checklist.check_list_id">
                <td>{{ index + 1 }}</td>
                <td>User</td>
                <td>{{ checklist.name }}</td>
                <td>
                    <span v-if="checklist.tags.length">
                        {{ checklist.tags.map(tag => tag.tag_name).join(', ') }}
                    </span>
                    <span v-else>Нет тегов</span>
                </td>
                <td>{{ checklist.items.length }}</td>
                <td>
                    <!-- Ползунок -->
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            :id="`isOnPublish-${index}`"
                            :checked="checklist.isOnPublish"
                            @change="togglePublish(checklist)"
                        >
                        <label class="form-check-label" :for="`isOnPublish-${index}`">
                            Публикация
                        </label>
                    </div>
                </td>
                <td>
                    <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="deleteCheckList(checklist)"
                    >
                        Удалить
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ChecklistsTable",
    data() {
        return {
            checklists: [], // Исходный список чек-листов
            loading: false, // Индикатор загрузки
        };
    },
    computed: {
        formattedChecklists() {
            // Возвращаем новый массив с преобразованным isOnPublish
            return this.checklists.map(checklist => ({
                ...checklist,
                isOnPublish: Number(checklist.isOnPublish) === 1, // Преобразуем 1/0 в true/false
            }));
        },
    },
    methods: {
        async fetchChecklists() {
            try {
                this.loading = true;
                const response = await axios.get("/api/checklist");
                this.checklists = response.data;
                console.log('Полученные данные:', this.checklists);
            } catch (error) {
                console.error("Ошибка загрузки чек-листов:", error);
            } finally {
                this.loading = false;
            }
        },
        async togglePublish(checklist) {
            try {
                // Инвертируем значение isOnPublish
                checklist.isOnPublish = !checklist.isOnPublish;

                // Отправляем обновленное значение на сервер
                await axios.patch(`/api/checklist/changePublish/${checklist.check_list_id}`, {
                    'isOnPublish': checklist.isOnPublish ? 1 : 0,
                });


            } catch (error) {
                console.error("Ошибка обновления статуса публикации:", error);
                // Возвращаем значение обратно, если произошла ошибка
                checklist.isOnPublish = !checklist.isOnPublish;
            }
        },
        async deleteCheckList(checklist) {
            try {
                await axios.delete(`api/checklist/delete/${checklist.check_list_id}`)
                this.fetchChecklists()
            } catch (error) {
                console.log(error);
            }
        }
    },
    mounted() {
        this.fetchChecklists();
    },
};
</script>
