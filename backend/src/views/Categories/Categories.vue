<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Categories</h1>
    <button type="button"
            @click="showAddNewModal()"
            class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Add new Category
    </button>
  </div>
  <CategoryTable @clickEdit="editCategory"/>
  <CategoryModal v-model="showCategoryModal" :category="categoryModel" @close="onModalClose"/>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import CategoryTable from "../Categories/CategoryTable.vue";
import CategoryModal from "../Categories/CategoryModal.vue";

const DEFAULT_CATEGORY = {
  id: '',
  name: '',
  description: '',
  slug: '',
  type: '',
  image: '',
  meta_description: '',
  meta_title: ''
}

const categories = computed(() => store.state.categories);
console.log(categories)
const categoryModel = ref({...DEFAULT_CATEGORY})
const showCategoryModal = ref(false);

function showAddNewModal() {
  showCategoryModal.value = true
}

function editCategory(c) {

  store.dispatch('getCategory', c.id)
    .then(({data}) => {
      console.log(data)
      categoryModel.value = data
      showAddNewModal();
    })
}

function onModalClose() {
  categoryModel.value = {...DEFAULT_CATEGORY}
}
</script>

<style scoped>

</style>
