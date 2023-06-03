<template>
  <Layout title="Дети">
    <ChildrenList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';
import ChildrenList from "@/components/ChildrenList/ChildrenList";
export default {
  name: 'ChildrensPage',
  components: {
    ChildrenList,
    Layout,
  }
}
</script>