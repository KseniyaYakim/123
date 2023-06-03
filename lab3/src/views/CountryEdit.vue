<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <CountryForm
        :id="id"
        @submit="onSubmit"
    />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';
import { updateItem, addItem } from '@/store/countries/selectors';
import Layout from '@/components/Layout/Layout';
import CountryForm from "@/components/CountryForm/CountryForm";
export default {
  name: 'CountryEdit',
  props: {
    id: String,
  },
  components: {
    Layout,
    CountryForm
  },
  setup() {
    const store = useStore();
    return {
      onSubmit: ({ id, country }) => id ?
          updateItem(store, { id, country }) :
          addItem(store, { country }),
    };
  }
}
</script>