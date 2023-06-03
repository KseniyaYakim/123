<template>
  <div :class="$style.root">

    <Table
      :headers="[
        {value: 'id', text: 'ID'},
        {value: 'name', text: 'Имя'},
        {value: 'age', text: 'Возраст'},
        {value: 'photo', text: 'Фото'},
        {value: 'country', text: 'Страна'},
        {value: 'control', text: 'Действие'},
      ]"

      :items="items"
    >
      <template v-slot:photo="{ item }">
      <img style="height:150px;width:200px;"  :src="'http://localhost/lab3/API/images/' + item.img_path">
    </template>
      <template v-slot:control="{ item }">
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
      </template>
    </Table>
    <router-link :to="{ name: 'ChildrenEdit' }">
      <Btn :class="$style.create" theme="info">Создать</Btn>
    </router-link>
  </div>
  <Btn v-if="$route.params.id" @click="onClickClear()" theme="danger" > Очистить фильтр </Btn>
</template>

<script>
import { useStore } from 'vuex';
import {computed,onMounted} from 'vue';
import { useRouter } from 'vue-router';
import { useRoute } from "vue-router";
import { selectItems, removeItem, fetchFiltered,fetchItems } from '@/store/childrens/selectors';
import { selectItems as selectCountryItems} from '@/store/countries/selectors';
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';
export default {
  name: 'ChildrenList',
  components: {
    Table,
    Btn,
  },
  setup() {
    const store = useStore();
    const router = useRouter();
    const route = useRoute();
    onMounted(() => {
      if (typeof route.params.id !== "undefined") {
        fetchFiltered(store,  route.params.id);
      }
      else
      {
        fetchItems(store);
      }
    });
    return {
      countries: computed(()=>selectCountryItems(store)),
      items: computed(() => selectItems(store)),
      onClickRemove: id => {
        const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
        if (isConfirmRemove) {
          removeItem(store, id)
        }
      },
      onClickEdit: id => {
        router.push({ name: 'ChildrenEdit', params: { id } })
      },
      onClickClear() {
        router.push({ name: 'Countries' });
        fetchItems(store);
      }
      }
    },
}
</script>

<style module lang="scss">
.root {
  .create {
    margin-top: 16px;
    text-align: center;
  }
}
</style>