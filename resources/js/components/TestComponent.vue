<template>
<button @click.prevent="testMeth">Test</button>
</template>

<script>
import apiClient from '../services/apiClient.js'; // Убедитесь, что импортирован ваш apiClient

export default {
    methods: {
        async testMeth() {
            try {

                const response = await apiClient.get('/test');
                console.log(response.data);
            } catch (error) {
                console.error('Error saving checklist:', error.response?.data || error.message);
            }
        }
    }
};

</script>
