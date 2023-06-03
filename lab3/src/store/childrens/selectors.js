export const fetchItems = (store) => {
  const { dispatch } = store;
  dispatch('childrens/fetchItems');
};
export const selectItems = (store) => {
  const { getters } = store;
  return getters['childrens/items']
}
export const fetchFiltered = (store, id) => {
  const { dispatch } = store;
  dispatch('childrens/fetchFiltered', id);
}
export const removeItem = (store, id) => {
  const { dispatch } = store;
  dispatch('childrens/removeItem', id);
}

export const addItem = (store, { name, age,img_path, country }) => {
  const { dispatch } = store;
  dispatch('childrens/addItem', { name, age,img_path, country });
}

export const updateItem = (store, { id, name, age,img_path, country }) => {
  const { dispatch } = store;
  dispatch('childrens/updateItem', { id,name, age,img_path, country });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['childrens/itemsByKey'][id] || {};
}