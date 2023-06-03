<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <ChildrenForm @submit="onSubmit" :id="id"  />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';
import { updateItem, addItem } from '@/store/childrens/selectors';
import ChildrenForm from '@/components/ChildrenForm/ChildrenForm';
import Layout from '@/components/Layout/Layout';
export default {
  name: 'CollectorEdit',
  props: {
    id: String,
  },
  components: {
    Layout,
    ChildrenForm,
  },
  setup() {
    const store = useStore();
    return {
      onSubmit: ({ id, name, age, img_path,country}) => id ?
          updateItem(store, { id,  name, age, img_path,country }) :
          addItem(store, {  name, age,img_path, country } )
    }
  }
}
</script>