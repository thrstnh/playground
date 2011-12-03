package de.haw.is.heap;

/**
 * 
 */
public class Pair<A extends Comparable<A>, B extends Comparable<B>>
        implements Comparable<Pair<A, B>> {

    private final A first;
    private final B second;

    /**
     * 
     * @param first
     * @param second
     */
    public Pair(A first, B second) {
        this.first = first;
        this.second = second;
    }

    /**
     * 
     * @return
     */
    public A getFirst() {
        return this.first;
    }

    /**
     * 
     * @return
     */
    public B getSecond() {
        return this.second;
    }

    /**
     * 
     * @param o
     * @return
     */
    @Override
    public boolean equals(Object o) {
        if (o == null) {
            throw new IllegalArgumentException("null is not a valid value!");
        }

        if (o instanceof Pair) {
            Pair otherPair = (Pair) o;
            if (!this.first.equals(otherPair.getFirst())) {
                return false;
            }
            if (!this.second.equals(otherPair.getSecond())) {
                return false;
            }
            return true;
        } else {
            return super.equals(o);
        }
    }

    /**
     * 
     * @return
     */
    @Override
    public int hashCode() {
        int hash = 7;
        hash = 19 * hash + (this.first != null ? this.first.hashCode() : 0);
        hash = 19 * hash + (this.second != null ? this.second.hashCode() : 0);
        return hash;
    }

    /**
     * 
     * @return
     */
    @Override
    public String toString() {
        StringBuffer sb = new StringBuffer();
        sb.append(this.first).append(",").append(this.second).append("\n");
//        sb.append("first: ").append(this.first);
//        sb.append("  <").append(this.first.getClass().toString()).append(">\n");
//        sb.append("second: ").append(this.second);
//        sb.append("  <").append(this.second.getClass().toString()).append(">\n");
        return sb.toString();
    }

    /**
     * 
     * @param o
     * @return
     */
    public int compareTo(Pair<A, B> o) {
        if (o == null) {
            throw new IllegalArgumentException("null is not a valid value!");
        }
        return this.first.compareTo(o.first);
    }

    /**
     * 
     * @param o
     * @return
     */
    public int compareToSecond(Pair<A, B> o) {
        if (o == null) {
            throw new IllegalArgumentException("null is not a valid value!");
        }
        return this.second.compareTo(o.second);
    }
}