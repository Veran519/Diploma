import { createStore } from 'vuex'

// Create a new store instance.
export const store = createStore({
  state () {
    return {
      isVisible: false
    }
  },
  mutations: {
    changeState (state, isAuth) {
      state.isVisible = isAuth;
      console.log(state.isVisible);
    }
  }
})