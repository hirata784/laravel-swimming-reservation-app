export default defineNuxtRouteMiddleware(() => {
    // トークンを取得
    const token = useCookie("token");
    // 認証をしている場合、予約一覧画面へ遷移する
    if (token.value) {
        return navigateTo("/list");
    }
});
