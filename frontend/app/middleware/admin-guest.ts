export default defineNuxtRouteMiddleware(() => {
    // トークンを取得
    const token = useCookie("token");
    // 今日の日付を取得
    const today = new Date();
    // 今年
    const year = today.getFullYear();
    // 今月(1~9月は頭を0で埋める(例：01月))
    const month = (today.getMonth() + 1).toString().padStart(2, "0");
    // 日付
    const date = today.getDate().toString().padStart(2, "0");
    // 現在の年月日
    const currentDate = `${year}-${month}-${date}`;
    // 未認証中のみ画面遷移できる
    // 認証中に遷移すると、予約管理画面へ遷移する
    if (token.value) {
        return navigateTo({
            path: "/admin/reservations",
            query: { date: currentDate },
        });
    }
});
