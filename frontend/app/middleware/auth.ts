export default defineNuxtRouteMiddleware((to) => {
    // トークンを取得
    const token = useCookie("token");
    // 認証中のみ画面遷移できる
    // 未認証中に遷移すると、ログイン画面へ遷移する
    if (!token.value) {
        return navigateTo({
            path: "/login",
            // 日時を含んだパスが入る
            query: {
                redirect: to.path,
                mode: to.query.mode,
            },
        });
    }
});
