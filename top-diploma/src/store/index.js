import { createStore } from 'vuex'; // Импортируем вьюкс 

// Create a new store instance.
export const store = createStore({    // Создаем новое состояние
  state () {
    return {
      isVisible: false
    }
  },
  mutations: {      // Добавялем мутации на изменение состояния
    changeState (state, isAuth) {
      state.isVisible = isAuth;     // Изменяем состояние при авторизации пользователя
    }
  }
})