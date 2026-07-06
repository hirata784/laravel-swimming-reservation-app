export default defineNuxtRouteMiddleware(() => {
    if (import.meta.server) return;

    const token = localStorage.getItem("token");

    // 認証をしている場合、予約一覧画面へ遷移する
    if (token) {
        return navigateTo("/list");
    }
});
