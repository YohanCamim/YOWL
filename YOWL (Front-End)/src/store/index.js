import { createStore } from 'vuex'
import settings from '@/settings.js'

const store = createStore({
	state: {
		users: [],
		username: "",
		userId: 0,
		token: "",
		likes: [],
		articlesDB: [],
		articles: [],
		article: {},
		comments: [],
		modeArticleUser: false,
		modeArticleFlux: false,
		filter: "",
		messageError: String,
	},
	mutations: {
		setUsername(state, username) { state.username = username },
		setToken(state, token) { state.token = token },
		setUserId(state, userId) { state.userId = userId },
		setArticles(state, articles) {
			if(!state.modeArticleFlux){
				state.articlesDB = articles;
				if(state.filter != settings.FILTER_NOVELTY){
					if(state.filter == settings.FILTER_BEST_RATED){
						articles.sort(function(article1, article2) {
							if(article1.ratingUp > article2.ratingUp) {
								return -1;
							} else if(article1.ratingUp < article2.ratingUp) {
								return 1;
							}
							return 0;
						});
					} else if(state.filter == settings.FILTER_POPULAR) {
						articles.sort(function(article1, article2) {
							if(article1.comments.length > article2.comments.length) {
								return -1;
							} else if(article1.comments.length < article2.comments.length) {
								return 1;
							}
							return 0;
						});
					}
				}
			}
			state.articles = articles;
		},
		setArticle(state, article) { state.article = article },
		setComments(state, comments) {
			comments.sort(function(comment1, comment2){
				if(comment1.rating > comment2.rating){
					return -1;
				} else if(comment1.rating < comment2.rating) {
					return 1;
				}
				return 0;
			});
			state.comments = comments;
		},
		setMessageError(state, error) { state.messageError = error },
		setModeArticleUser(state, modeArticleUser) { state.modeArticleUser = modeArticleUser },
		setModeArticleFlux(state, modeArticleFlux) { state.modeArticleFlux = modeArticleFlux },
		setFilter(state, filter) { state.filter = filter },
		setUsers(state, users){ state.users = users },
		setLikes(state, likes){ state.likes = likes },
	},
	getters: {
		isConnected(state) { return (state.token.length > 0) ? 1 : 0 },
		username(state) { return state.username },
		getterArticles(state) { return state.articles },
	},
	actions: {
		//#region LOGOUT
		logout({ commit }) {
			fetch(settings.SERVICE_URI + "logout", {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', accept: 'application/json', Authorization: `Bearer ${this.state.token}` },
			}).then((res) => {
				res.json().then(() => {
					commit('setToken', "")
					commit('setUsername', "")
					commit('setUserId', 0)
				})
			})
		},
		//#endregion

		//#region USERS
		getUsers({ commit }) {
			fetch(settings.SERVICE_URI + "users", {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			}).then((result) => {
				result.json().then((data) => {
					commit('setUsers', data)
				})
			})
		},
		//#endregion

		//#region LIKES
		getLikes({ commit }) {
			fetch(settings.SERVICE_URI + "news/liked", {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', accept: 'application/json', Authorization: `Bearer ${this.state.token}` }
			}).then((result) => {
				result.json().then((data) => {
					commit('setLikes', data)
				})
			})
		},
		//#endregion	

		//#region ARTICLE
		// ------------------------------------------- GET
		getArticles({ commit }) {
			fetch(settings.SERVICE_URI + "news", {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			}).then((result) => {
				result.json().then((data) => {
					commit('setArticles', data)
				})
			})
		},
		getArticle({ commit }, id) {
			fetch(settings.SERVICE_URI + "news/" + id, {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' },
			}).then((res) => {
				res.json().then((data) => {
					commit('setArticle', data[0])
				})
			})
		},
		getArticlesUser({ commit }, id) {
			fetch(settings.SERVICE_URI + "news/author/" + id, {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' },
			}).then((res) => {
				res.json().then((data) => {
					commit('setArticles', data)
				})
			})
		},
		addArticle({ dispatch }, obj) { // { 'idUser':'...' 'url':'...' }
			fetch(settings.SERVICE_URI + "news", {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', accept: 'application/json', Authorization: `Bearer ${this.state.token}` },
				body: JSON.stringify({ 'url': obj.url }),
			}).then((res) => {
				if (res.ok) {
					if(obj.flux == false){
						dispatch('getArticles')
					}					
				}
			})
		},
		// ------------------------------------------- SEARCH
		searchArticles({ commit }, searchTxt) {
			fetch(settings.SERVICE_URI + "news/search/" + searchTxt, {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			}).then((result) => {
				result.json().then((data) => {
					commit('setArticles', data)
				})
			});
		},
		searchArticlesUser({ commit }, obj) {
			fetch(settings.SERVICE_URI + "news/search/author/" + obj.text + "/" + obj.id, {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			}).then((result) => {
				result.json().then((data) => {
					commit('setArticles', data)
				})
			});
		},
		// ------------------------------------------- DELETE
		deleteArticle({ dispatch, commit }, id) {
			fetch(settings.SERVICE_URI + `/articles/${id}` + '?force=true', {
				method: 'DELETE',
				headers: { 'Content-Type': 'application/json', accept: 'application/json', Authorization: `Bearer ${this.state.token}` },
			}).then((res) => {
				if (res.status == 200) {
					dispatch('getArticles')
				} else {
					res.json().then((data) => {
						commit('setArticles', data.error.message)
					})
				}
			})
		},
		//#endregion

		//#region FLUX
		getArticlesFlux({ commit }) {
			fetch(settings.SERVICE_URI + "flux", {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			}).then((result) => {
				result.json().then((data) => {
					commit('setArticles', data)
				})
			})
		},
		getNamesFlux({ commit }) {
			fetch(settings.SERVICE_URI + "fluxNames", {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			}).then((result) => {
				result.json().then((data) => {
					commit('setArticles', data)
				})
			})
		},
		//#endregion

		//#region COMMENT
		getComments({ commit }) {
			fetch(settings.SERVICE_URI + "/comments", {
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			}).then((result) => {
				result.json().then((data) => {
					commit('setComments', data)
				})
			});
		},
		getCommentsArticle({ commit }, id) {
			fetch(settings.SERVICE_URI + "comments/news/" + id, {
				method: "GET",
				headers: { "Content-Type": "application/json" },
			}).then((result) => {
				result.json().then((data) => {
					commit('setComments', data)
				});
			});
		},
		addComment({ dispatch, commit }, obj) {
			fetch(settings.SERVICE_URI + "comments", {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', accept: 'application/json', Authorization: `Bearer ${this.state.token}` },
				body: JSON.stringify({ content: obj.content, news_id: obj.id_article}),
			}).then((res) => {
				if (res.ok) {
					dispatch('getCommentsArticle', obj.id_article)
				} else {
					res.json().then((data) => {
						commit('setArticles', data.error.message)
					})
				}
			})
		},
		addCommentResponse({ dispatch, commit }, obj) {
			fetch(settings.SERVICE_URI + "comments", {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', accept: 'application/json', Authorization: `Bearer ${this.state.token}` },
				body: JSON.stringify({ content: obj.content, news_id: obj.news_id, parent_id: obj.parent_id}),
			}).then((res) => {
				if (res.ok) {
					dispatch('getCommentsArticle', obj.news_id)
				} else {
					res.json().then((data) => {
						commit('setArticles', data.error.message)
					})
				}
			})
		},
		//#endregion
	},
})

export default store
