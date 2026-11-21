import type { VariantProps } from "class-variance-authority"
import { cva } from "class-variance-authority"

export { default as Button } from "./Button.vue"

export const buttonVariants = cva(
  "inline-flex items-center justify-center gap-1 whitespace-nowrap rounded-xl text-sm font-raleway font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[2px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive",
  {
    variants: {
      variant: {
        default:
          "font-semibold bg-blue-500 text-primary-foreground hover:bg-blue-600 focus-visible:ring-blue-500/20",
        destructive:
          "bg-red-600 text-primary-foreground hover:bg-red-700 focus-visible:ring-red-600/10",
        outline:
          "border border-[1px] border-gray-200 bg-white hover:bg-gray-50 focus-visible:ring-blue-500/20 focus-visible:border-[#8ECCFF]",
        secondary:
          "font-semibold bg-blue-500/10 text-primary hover:bg-blue-500/20 focus-visible:ring-blue-500/20 focus-visible:border-[1px] focus-visible:border-[#8ECCFF]",
        ghost:
          "hover:bg-accent hover:text-primary focus-visible:ring-blue-500/20 focus-visible:border-[1px] focus-visible:border-[#8ECCFF]",
        link: "text-primary underline-offset-4 hover:underline hover:text-blue-600 focus-visible:ring-blue-500/20 focus-visible:border-[1px] focus-visible:border-[#8ECCFF]",
      },
      size: {
        "default": "h-9 px-4 py-2 has-[>svg]:px-3",
        "sm": "h-8 rounded-md gap-0.5 px-3 has-[>svg]:px-2.5",
        "lg": "h-10 rounded-md px-6 has-[>svg]:px-4",
        "icon": "size-9",
        "icon-sm": "size-8",
        "icon-lg": "size-10",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
)
export type ButtonVariants = VariantProps<typeof buttonVariants>
