export default defineNuxtRouteMiddleware(() => {
    // トークンを取得
    const token = useCookie("token");
    // 未認証中のみ画面遷移できる
    // 認証中に遷移すると、予約一覧画面へ遷移する
    if (token.value) {
        return navigateTo("/list");
    }
});
