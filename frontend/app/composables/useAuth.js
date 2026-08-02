export const useAuth = () => {
    const cookieToken = useCookie("token");
    const token = useState("token", () => cookieToken.value || null);
    const user = useState("user", () => null);

    watch(token, (newVal) => {
        cookieToken.value = newVal;
    });

    // tokenがある場合、ユーザー名を取得する
    const fetchUser = async () => {
        if (!token.value) return;

        const res = await $fetch("http://localhost/api/auth/user", {
            headers: {
                Authorization: `Bearer ${token.value}`,
            },
        });

        user.value = res;
    };

    return {
        user,
        token,
        fetchUser,
    };
};
