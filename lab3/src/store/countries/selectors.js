export const fetchItems = ( store ) => {
  const { dispatch } = store;
  dispatch('countries/fetchItems');
};
export const selectItems = ( store ) => {
  const { getters } = store;
  return getters['countries/items']
}

export const removeItem = ( store, id ) => {
  const { dispatch } = store;
  dispatch('countries/removeItem', id);
}

export const addItem = ( store, {country} ) => {
  const { dispatch } = store;
  dispatch('countries/addItem', {country });
}

export const updateItem = ( store, { id, country}) => {
  const { dispatch } = store;
  dispatch('countries/updateItem', { id, country});
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['countries/itemsByKey'][id] || {};
}