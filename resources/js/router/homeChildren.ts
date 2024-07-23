import Dashboard from "../views/Dashboard.vue";

const childRoutes = [
    {
        path: "",
        name: "dashboard",
        component: Dashboard,
    },
    {
        path: "members",
        name: "members",
        component: () => import("../views/Members.vue"),
    },
    {
        path: "attendance",
        name: "attendance",
        component: () => import("../views/Attendance.vue"),
    },
];

export function homeChildren() {
    return childRoutes;
}
