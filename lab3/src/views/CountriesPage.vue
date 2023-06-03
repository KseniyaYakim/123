<template>
  <Layout title="Страны">
    <CountryList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';
import CountryList from "@/components/CountryList/CountryList";
export default {
  name: 'CountriesPage',
  components: {
    CountryList,
    Layout
  }
}
</script>