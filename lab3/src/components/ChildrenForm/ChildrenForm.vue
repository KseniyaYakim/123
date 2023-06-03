<template>
  <div :class="$style.root">
    <div v-if="form.id" :class="$style.item">
      <div :class="$style.label">
        <label for="id">ID</label>
      </div>
      <input v-model="form.id" disabled :class="$style.input"  id="id" placeholder="id" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="name">Имя</label>
      </div>
      <input v-model="form.name" :class="$style.input"  id="name" placeholder="Имя" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="age">Возраст</label>
      </div>
      <input v-model="form.age" :class="$style.input"  id="age" placeholder="Возраст" type="number">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="img_path">Фото</label>
      </div>
      <input  :class="$style.input"  id="img_path" placeholder="Фото" type="file" accept="image/*" @change="form.img_path = uploadImage($event)" >
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="country">Страна</label>
      </div>
      <select v-model="form.country" :class="$style.select"  id="country">
        <option v-for="({ country, id  }) in countryList" :key="id" :value="id">
        {{country}}
        </option>
      </select>
    </div>

    <div :class="$style.item">
      <Btn @click="onClick" :disabled="!isValidForm" theme="info">Сохранить</Btn>
    </div>
  </div>
</template>

<script>
import { computed, reactive, onBeforeMount, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import {selectItemById, fetchItems} from '@/store/childrens/selectors';
import { selectItems as selectCountries, fetchItems as fetchCountries } from '@/store/countries/selectors';
import Btn from '@/components/Btn/Btn';
import axios from "axios";
export default {
  name: 'ChildrenForm',
  props: {
    id: { type: String, default: '' },
  },
  components: {
    Btn,
  },
  methods: {
    uploadImage(event) {
      const URL = 'http://localhost/lab3/API/rest/index.php/childrens/upload-image';
      let data = new FormData();
      data.append('name', 'my-picture');
      data.append('file', event.target.files[0]);
      let config = {
        method: 'post',
        header : {
          'Content-Type' : 'image/png'
        }
      }
      axios.post(
          URL,
          data,
          config
      ).then(
          response => {
            console.log('image upload response > ', response)
          }
      )
      var fileData =  event.target.files[0];
      return fileData.name;
    }
  },
  setup(props, context) {
    const store = useStore();
    const router = useRouter();
    const countryList = computed(() => selectCountries(store))
    const form = reactive({
      id: '',
      name: '',
      img_path: '',
      age: '',
      country: '',
    });
    onBeforeMount(() => {
      fetchItems(store);
      fetchCountries(store);
    });
    watchEffect(() => {
      const children = selectItemById( store,  props.id );
      Object.keys(children).forEach(key => {
        form[key] = children[key]
      })
    });
    return {
      countryList,
      form,
      isValidForm: computed(() =>  !!(form.name && form.age&& form.country&& form.img_path)),
      onClick: () => {
        context.emit('submit', form);
        router.push({ name: 'Childrens' })
      }
    }
  },
}
</script>

<style module lang="scss">
.root {
  padding-top: 30px;
  max-width: 900px;
  .item {
    display: flex;
    align-items: center;
    & + .item {
      margin-top: 15px;
    }
  }
  .label {
    flex: 0 0 150px
  }
  .input {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
  }
  .select {
    display: block;
    width: 100%;
    padding: 0.375rem 2.25rem 0.375rem 0.75rem;
    -moz-padding-start: calc(0.75rem - 3px);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    appearance: none;
  }
}
</style>