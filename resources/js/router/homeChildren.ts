import Dashboard from "../views/Dashboard.vue";

const childRoutes = [
    {
        path: "",
        name: "dashboard",
        component: Dashboard,
    },
    {
        path: "email-templates",
        name: "email-templates",
        component: () => import("../views/EmailTemplate.vue"),
    },
    {
        path: "sms-emplates",
        name: "sms-templates",
        component: () => import("../views/SmsTemplate.vue"),
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
    {
        path: "messages",
        name: "messages",
        component: () => import("../views/Messages.vue"),
    },
    {
        path: "attendants",
        name: "attendants",
        component: () => import("../views/Attendants.vue"),
    },
];

export function homeChildren() {
    return childRoutes;
}
